<?php

namespace app\controllers\api;

use app\models\Participant;
use Yii;

class ParticipantController extends \yii\rest\ActiveController

{
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
}
