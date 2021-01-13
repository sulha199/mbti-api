<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participant_perspective".
 *
 * @property int $id
 * @property int $participant_id
 * @property int $ei
 * @property int $sn
 * @property int $tf
 * @property int $jp
 *
 * @property Participant $participant
 */
class ParticipantPerspective extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participant_perspective';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['participant_id', 'ei', 'sn', 'tf', 'jp'], 'required'],
            [['participant_id', 'ei', 'sn', 'tf', 'jp'], 'integer'],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id' => 'id']],
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
            'ei' => 'Ei',
            'sn' => 'Sn',
            'tf' => 'Tf',
            'jp' => 'Jp',
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
}
