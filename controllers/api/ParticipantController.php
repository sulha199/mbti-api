<?php

namespace app\controllers\api;

use Yii;
use app\models\Participant;
use app\models\ParticipantPerspective;

class ParticipantController extends \yii\rest\ActiveController
{
    use CorsUtil;
    public $modelClass = 'app\models\Participant';

    public function actionSubmit() {
        $model = new Participant;

        if (
            $model->loadAll(Yii::$app->request->post()) 
            && $model->saveAll()
        ) {
            return $model->getAttributesWithRelated();
        }   
    }

    public function actionPerspective(string $email) {
        $model = Participant::find()->where([ 'email' => $email])->orderBy('id desc')->with('participantPerspective')->one();
        return $model->getAttributesWithRelated();
    }
}
