const {validationResult} = require('express-validator');
const bcrypt = require('bcryptjs');
const conn = require('../connection').promise();

exports.register = async(req,res,next) => {
    const errors = validationResult(req);

    if(!errors.isEmpty()){
        return res.status(422).json({ errors: errors.array() });
    }

    try{

        const [row] = await conn.execute(
            "SELECT `email` FROM `users` WHERE `email`=?",
            [req.body.email]
        );

        if (row.length > 0) {
            return res.status(201).json({
                message: "The E-mail already in use",
            });
        }

        const hashPass = await bcrypt.hash(req.body.password, 12);
        // console.log(req.body, "blalalalal")
        const [rows] = await conn.execute('INSERT INTO `users`(`username`,`first_name`,`last_name`,`email`,`password`,`bio`) VALUES(?,?,?,?,?,?)',[
            req.body.username,
            req.body.first_name,
            req.body.last_name,
            req.body.email,
            hashPass,
            req.body.bio,
        ]);

        if (rows.affectedRows === 1) {
            return res.status(201).json({
                message: "The user has been successfully inserted.",
            });
        }

    }catch(err){
        next(err);
    }
}