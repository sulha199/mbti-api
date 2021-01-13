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
     * Gets query for [[ParticipantPerspectives]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantPerspectives()
    {
        return $this->hasMany(ParticipantPerspective::className(), ['participant_id' => 'id']);
    }
}
