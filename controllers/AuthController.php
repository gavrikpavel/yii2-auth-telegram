<?php

namespace app\controllers;

use app\components\bot\jobs\UpdateJob;
use app\models\ConfirmForm;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\Update;
use app\models\User;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        // Read User Status in session
        if ($this->waitReg()) {return $this->redirect('confirm');}

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $update = new Update();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $id = Yii::$app->queue->push(new UpdateJob([
                    'offset' => $update->getOffset(),
                ]));
                // Save User Status in session
                $this->setReg();
                return $this->redirect('confirm');
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionConfirm()
    {
        $model = new ConfirmForm();
        if ($model->load(Yii::$app->request->post()) && $model->validateConfirmToken()) {
            $this->confirmReg();
            return $this->redirect('login');
        }
        return $this->render('confirm', [
            'model' => $model,
        ]);

    }

    /**
     * function fo AJAX validation user (in view 'signup' /auth/validation-user )
     *
     * @return array
     */
    public function actionValidationUser()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * @return bool
     */
    public function waitReg()
    {
        $session = Yii::$app->session;
        if ($session->has('status')) {
            $status = $session['status'];
            return ($status == 'wait')  ? true : false;
        }
    }

    public function setReg()
    {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
            $session['status'] = 'wait';
        }
    }

    public function confirmReg()
    {
        $session = Yii::$app->session;
        $session->close();
        $session->destroy();
    }

}