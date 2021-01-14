<?php

namespace app\controllers\api;

use Yii;
use app\models\Participant;
use app\models\ParticipantPerspective;

class ParticipantController extends \yii\rest\ActiveController

{
    public $modelClass = 'app\models\Participant';

    public function actionSubmit() {
        $model = new Participant;

        if (
            $model->loadAll(Yii::$app->request->post()) 
            && $model->saveAll()
        ) {
            $perspective = $model->calculatePerspectiveFromAnswers();
            $model->link('participantPerspectives', $perspective);
            $perspective->save();
            $response = $model->getAttributesWithRelated();
            $response['participantPerspectives'] = [ $perspective->attributes ];
            return $response;
        }   
    }

    public function actionPerspective(int $id) {
        $model = ParticipantPerspective::findOne([ 'participant_id' => $id ]);
        return $model;
    }
}
