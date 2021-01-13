<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participant_answer".
 *
 * @property int $id
 * @property int $participant_id
 * @property int $question_id
 * @property int $score
 *
 * @property Participant $participant
 * @property Question $question
 */
class ParticipantAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participant_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['participant_id', 'question_id', 'score'], 'required'],
            [['participant_id', 'question_id', 'score'], 'integer'],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'participant_id' => 'Participant ID',
            'question_id' => 'Question ID',
            'score' => 'Score',
        ];
    }

    /**
     * Gets query for [[Participant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id']);
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }
}
