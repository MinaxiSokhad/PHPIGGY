<?php
declare(strict_types=1);
namespace App\Services;
use Framework\Database;
class ProfileService{
    public function __construct(private Database $db)
    {

    }
    public function getUserProfile(int $id){
        //dd($id);
        return $this->db->query(
            "SELECT * FROM users WHERE id= :id",
            [
                'id' => $_SESSION['user']
            ]
        )->find();
    }
    public function updateData(array $formData){
        $password = password_hash($formData['password'],PASSWORD_BCRYPT,['cost'=>12]);
        return $this->db->query(
            "UPDATE users SET
             email=:email,age=:age,country=:country,social_media_url=:social_media_url,password=:password WHERE id=:id",
             [
                'email' => $formData['email'],
                'age' => $formData['age'],
                'country' => $formData['country'],
                'social_media_url' => $formData['socialMediaURL'],
                'password' => $password,
                'id'=> $_SESSION['user']

             ]
             );
    }
}