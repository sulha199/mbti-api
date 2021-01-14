<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participant".
 *
 * @property int $id
 * @property string $email
 * @property string $timestamp
 *
 * @property ParticipantAnswer[] $participantAnswers
 * @property ParticipantPerspective[] $participantPerspectives
 */
class Participant extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['timestamp'], 'safe'],
            [['email'], 'string', 'max' => 100],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'timestamp' => 'Timestamp',
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        $perspective = $this->calculatePerspectiveFromAnswers();
        $this->link('participantPerspective', $perspective);
        $perspective->save();
        
        $newData = $this->getAttributesWithRelatedAsPost();
        $newData['ParticipantPerspective'] = $perspective->attributes;
        $this->loadAll($newData); 

        parent::afterSave($insert, $changedAttributes);
    }


    public function calculatePerspectiveFromAnswers() {
        $answers = $this->participantAnswers;
        $perspectiveScore = new ParticipantPerspective();

        foreach ($answers as $answer) {
            $question = $answer->question;
            $meaning = $answer->score > 4 ? $question->meaning : str_replace($question->meaning, '', $question->dimension);
            $perspectiveScoreKey = strtolower($question->dimension)."_".strtolower($meaning);
            $perspectiveScore->$perspectiveScoreKey += abs($answer->score - 4);
        }

        return $perspectiveScore;
    }

    /**
     * Gets query for [[ParticipantAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantAnswers()
    {
        return $this->hasMany(ParticipantAnswer::className(), ['participant_id' => 'id']);
    }

    /**
     * Gets query for [[ParticipantPerspective]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantPerspective()
    {
        return $this->hasOne(ParticipantPerspective::className(), ['participant_id' => 'id']);
    }
}
