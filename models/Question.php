<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $dimension
 * @property int|null $direction
 * @property string|null $meaning
 *
 * @property ParticipantAnswer[] $participantAnswers
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['direction'], 'integer'],
            [['question'], 'string', 'max' => 87],
            [['dimension'], 'string', 'max' => 2],
            [['meaning'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'dimension' => 'Dimension',
            'direction' => 'Direction',
            'meaning' => 'Meaning',
        ];
    }

    /**
     * Gets query for [[ParticipantAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantAnswers()
    {
        return $this->hasMany(ParticipantAnswer::className(), ['question_id' => 'id']);
    }
}
