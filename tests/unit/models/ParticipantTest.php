<?php

namespace tests\unit\models;

use app\models\Participant;
use app\models\ParticipantAnswer;

class ParticipantTest extends \Codeception\Test\Unit
{
    private $testCaseJson = '[
        {
            "case": "Test Case A",
            "question1": 4,
            "question2": 3,
            "question3": 1,
            "question4": 6,
            "question5": 7,
            "question6": 3,
            "question7": 5,
            "question8": 3,
            "question9": 6,
            "question10": 6,
            "Result": "ENTP"
        },
        {
            "case": "Test Case B",
            "question1": 1,
            "question2": 5,
            "question3": 4,
            "question4": 6,
            "question5": 5,
            "question6": 2,
            "question7": 6,
            "question8": 3,
            "question9": 3,
            "question10": 2,
            "Result": "ESTJ"
        },
        {
            "case": "Test Case D",
            "question1": 3,
            "question2": 2,
            "question3": 6,
            "question4": 1,
            "question5": 7,
            "question6": 3,
            "question7": 2,
            "question8": 5,
            "question9": 2,
            "question10": 7,
            "Result": "INFP"
        },
        {
            "case": "Test Case E",
            "question1": 3,
            "question2": 4,
            "question3": 7,
            "question4": 1,
            "question5": 2,
            "question6": 5,
            "question7": 4,
            "question8": 3,
            "question9": 2,
            "question10": 6,
            "Result": "ISFP"
        },
        {
            "case": "Test Case F",
            "question1": 4,
            "question2": 4,
            "question3": 4,
            "question4": 4,
            "question5": 4,
            "question6": 4,
            "question7": 4,
            "question8": 4,
            "question9": 4,
            "question10": 4,
            "Result": "ESTJ"
        },
        {
            "case": "Test Case G",
            "question1": 1,
            "question2": 1,
            "question3": 1,
            "question4": 1,
            "question5": 1,
            "question6": 1,
            "question7": 1,
            "question8": 1,
            "question9": 1,
            "question10": 1,
            "Result": "ISTJ"
        },
        {
            "case": "Test Case H",
            "question1": 7,
            "question2": 7,
            "question3": 7,
            "question4": 7,
            "question5": 7,
            "question6": 7,
            "question7": 7,
            "question8": 7,
            "question9": 7,
            "question10": 7,
            "Result": "ESTP"
        }
    ]';
    private $model;
    
    public function testCalculatePerspective()
    {
        $testCaseValue = json_decode($this->testCaseJson);
        expect(count($testCaseValue))->equals(7);

        foreach ($testCaseValue as $index => $case) {
            $participant = new Participant;
            $participant->email = 'aaa@email.com';
            $participant->save();
            foreach ($case as $label => $value) {
                if (str_contains($label, 'question')) {
                    $question_id = str_replace('question', '', $label);
                    $answer = new ParticipantAnswer;
                    $answer->question_id = $question_id;
                    $answer->score = $value;
                    $participant->link('participantAnswers', $answer);
                }
            }
            $perspective = $participant->calculatePerspectiveFromAnswers();
            $perspective->beforeSave(true);
            
            expect(count($participant->participantAnswers))->equals(10);
            expect($perspective->summary)->equals($case->Result);
        }
    }

}
