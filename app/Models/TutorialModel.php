<?php

namespace App\Models;

use App\System\Model;

class TutorialModel extends Model
{
    protected $table = 'user_ci_tutorial';
    protected $primaryKey = 'user_id';

    protected $allowedFields = ['user_id', 'type', 'email', 'password', 'date_added'];

    /**
     *  Get one or many users
     *  
     *  @param integer|void $user_id
     *  
     *  @return array 
     */
    public function get($user_id = null)
    {
        if ($user_id == null) {
            $query = $this->db->get('user_ci_tutorial');
        } else {
            $query = $this->db->get_where('user_ci_tutorial',array('user_id' => $user_id));
        }
        return $query->result();
    }
    
    /**
     *  Attempts to validate and log a user in
     *  
     *  @param string $type admin or user
     *  @param string $email
     *  @param string $password do not encrypt
     *  
     *  @return array
     */
    public function login($type, $email, $password)
    {
        // $query = $this->db->get_where('user_ci_tutorial', array(
        //     'type' => $type,
        //     'email' => $email,
        //     'password' => sha1($password . HASH_KEY)
        // ));

        // return $query->result();

        return $this->where('type', $type)
                    ->where('email', $email)
                    ->where('password', sha1($password . HASH_KEY))
                    ->first();           
    }
    
    public function create($email, $password)
    {
        // $this->form_validation->set_rules('email', 'Email', 'is_unique[user_ci_tutorial.email]');
        // if ($this->form_validation->run() == false) {
        //     return false;
        // }

        // Create the record
        $result = $this->insert([
            'email' => $email,
            'password' => sha1($password . HASH_KEY),
            'date_added' => date('Y-m-d H:i:s')
        ]);
        return $result;
    }
    
    // public function delete($user_id)
    // {
    //     $this->db->where(array('user_id' => $user_id));
    //     echo $this->db->delete('user_ci_tutorial');
    // }

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    // public function getNews($slug = false)
    // {
    //     if ($slug === false) {
    //         return $this->findAll();
    //     }

    //     return $this->where(['slug' => $slug])->first();
    // }
}



