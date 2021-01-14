<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participant_perspective".
 *
 * @property int $id
 * @property int $participant_id
 * @property int $ei_i
 * @property int $ei_e
 * @property int $sn_s
 * @property int $sn_n
 * @property int $tf_t
 * @property int $tf_f
 * @property int $jp_j
 * @property int $jp_p
 * @property string $summary
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
            [['participant_id', 'summary'], 'required'],
            [['participant_id', 'ei_i', 'ei_e', 'sn_s', 'sn_n', 'tf_t', 'tf_f', 'jp_j', 'jp_p'], 'integer'],
            [['summary'], 'string', 'max' => 4],
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
            'ei_i' => 'Ei I',
            'ei_e' => 'Ei E',
            'sn_s' => 'Sn S',
            'sn_n' => 'Sn N',
            'tf_t' => 'Tf T',
            'tf_f' => 'Tf F',
            'jp_j' => 'Jp J',
            'jp_p' => 'Jp P',
            'summary' => 'Summary',
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

    public function beforeSave($insert)
    {
        $this->summary = $this->calculateSummary();
        return parent::beforeSave($insert);
    }

    public function calculateSummary() {
        return ($this->ei_i > $this->ei_e ? 'I' : 'E').
            ($this->sn_n > $this->sn_s ? 'N' : 'S').
            ($this->tf_f > $this->tf_t ? 'F' : 'T').
            ($this->jp_p > $this->jp_j ? 'P' : 'J');
    }
}
