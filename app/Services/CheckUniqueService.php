<?php

namespace App\Services;

use App\Repositories\AccountPhoneRepository;
use App\Repositories\AdminsRepository;
use App\Repositories\UsersRepository;

class CheckUniqueService
{
    protected $adminsRepository;
    protected $usersRepository;
    protected $accountPhoneRepository;

    public function __construct(AdminsRepository $adminsRepository, UsersRepository $usersRepository, AccountPhoneRepository $accountPhoneRepository)
    {
        $this->adminsRepository = $adminsRepository;
        $this->usersRepository = $usersRepository;
        $this->accountPhoneRepository = $accountPhoneRepository;
    }


    /**
     * 唯一验证
     * @param string $table_name
     * @param string $field
     * @param string $value
     * @param int|null $id
     * @return bool
     */
    public function check(string $table_name, string $field, string $value, int $id = null, string $name = null)
    {
        switch ($table_name) {
            case 'admins':
                $result = $this->adminsRepository->searchOne($field, $value, $id);
                break;

            case 'users':
                $result = $this->usersRepository->searchCheck($field, $value, $id);
                break;

            case 'account_phones':
                $result = $this->accountPhoneRepository->searchCheck($id, $value, $name);
                if ($result) {
                    for ($i = 0; $i < count($result); $i++) {
                        if ($result[$i] == $name) {
                            return $result = 0;
                        }
                    }

                } else {

                    return $result = 1;
                }
                break;

            default :
                return false;
        }

        return $result = $result ? false : true;
    }

}
