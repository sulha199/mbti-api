<?php

namespace app\controllers\api;

use Yii;
use app\models\Participant;

class ParticipantController extends \yii\rest\ActiveController
{
    use CorsUtil;
    public $modelClass = 'app\models\Participant';

    public function actionSubmit() {
        $model = new Participant;

        if (
            $model->loadAll(Yii::$app->request->post()) 
        ) {
            if ($model->saveAll()) {
                return $model->getAttributesWithRelated();
            } else {
                $response = Yii::$app->response;
                $response->data = $model->errors;
                $response->statusCode = 500;
                return $response;
            }
        }   
    }

    public function actionPerspective(string $email) {
        $model = Participant::find()->where([ 'email' => $email])->orderBy('id desc')->with('participantPerspective')->one();
        return $model->getAttributesWithRelated();
    }
}
