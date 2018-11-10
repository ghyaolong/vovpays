<?php

namespace App\Services;
use App\Repositories\AdminsRepository;
use App\Repositories\UsersRepository;

class CheckUniqueService
{
    protected $adminsRepository;
    protected $usersRepository;

    public function __construct(AdminsRepository $adminsRepository, UsersRepository $usersRepository)
    {
        $this->adminsRepository = $adminsRepository;
        $this->usersRepository  = $usersRepository;
    }


    /**
     * 唯一验证
     * @param string $table_name
     * @param string $field
     * @param string $value
     * @param int|null $id
     * @return bool
     */
    public function check(string $table_name, string $field, string $value, int $id = null )
    {

        switch ($table_name)
        {
            case 'admins':

                if($id)
                {
                    if($field == 'email')
                    {
                        $result = $this->adminsRepository->findEmailNotId($value, $id);
                    }else if($field == 'username'){
                        $result = $this->adminsRepository->findUsernameNotId($value, $id);
                    }else if($field == 'phone'){
                        $result = $this->adminsRepository->findPhoneNotId($value, $id);
                    }
                }else{
                    if($field == 'email')
                    {
                        $result = $this->adminsRepository->findEmail($value);
                    }else if($field == 'username'){
                        $result = $this->adminsRepository->findUsername($value);
                    }else if($field == 'phone'){
                        $result = $this->adminsRepository->findPhone($value);
                    }
                }
                break;
            case 'users':
                if($id)
                {
                    if($field == 'email')
                    {
                        $sql = "id <> $id and email = ?";
                        $where['email'] = $value;

                    }else if($field == 'username'){
                        $sql = "id <> $id and username = ?";
                        $where['username'] = $value;

                    }else if($field == 'phone'){
                        $sql = "id <> $id and phone = ?";
                        $where['phone'] = $value;
                    }
                }else{
                    if($field == 'email')
                    {
                        $sql = " email = ?";
                        $where['email'] = $value;

                    }else if($field == 'username'){

                        $sql = " username = ?";
                        $where['username'] = $value;

                    }else if($field == 'phone'){

                        $sql = " phone = ?";
                        $where['phone'] = $value;
                    }
                }
                break;
            default :
                return false;
        }

        $result = $this->usersRepository->searchOne($sql, $where);
        return $result = $result ? false : true;
    }

}
