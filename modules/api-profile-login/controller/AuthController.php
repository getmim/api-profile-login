<?php
/**
 * AuthController
 * @package api-profile-login
 * @version 0.0.1
 */

namespace ApiProfileLogin\Controller;

use ProfileAuth\Model\ProfileSession as PSession;
use Profile\Model\Profile;

use LibForm\Library\Form;

class AuthController extends \Api\Controller
{
    public function loginAction(){
        if($this->profile->isLogin())
            return $this->resp(401);

        if(!$this->app->isAuthorized())
            return $this->resp(401);

        $form = new Form('api.profile.login');
        if(!($valid = $form->validate()))
            return $this->resp(422, $form->getErrors());

        $profile = Profile::getOne([
            '$or' => [
                [ 'email' => $valid->name ],
                [ 'phone' => $valid->name ],
                [ 'name'  => $valid->name ]
            ]
        ]);

        if(!$profile || !password_verify($valid->password, $profile->password)){
            $form->addError('name', '0.0', 'Profile not found or wrong password');
            return $this->resp(422, $form->getErrors());
        }

        $session = [
            'app'     => $this->app->id,
            'profile' => $profile->id,
            'hash'    => null,
            'expires' => date('Y-m-d H:i:s', strtotime('+7 days'))
        ];

        $unbearer = '';
        while(true){
            $hash = base64_encode(password_hash(uniqid().'.'.uniqid(), PASSWORD_DEFAULT));
            $hash = strrev($hash);

            $unbearer = strtolower(trim($hash, '='));
            $hash = 'bearer ' . $unbearer;

            if(PSession::getOne(['hash'=>$hash]))
                continue;

            $session['hash'] = $hash;
            break;
        }

        PSession::create($session);

        $this->resp(0, ['token' => $unbearer]);
    }
}