<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class InstallPlugIn extends BaseController
{
    /**
     * @api {get} /user/:id Request User information
     * @apiName GetUser
     * @apiGroup User
     *
     * @apiParam {Number} id Users unique ID.
     *
     * @apiSuccess {String} firstname Firstname of the User.
     * @apiSuccess {String} lastname  Lastname of the User.
     */
    public function index()
    {
        //
        echo 'hello';
    }
}
