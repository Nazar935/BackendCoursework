<?php

namespace controllers;

use core\Controller;
use core\Core;
use core\Utils;
use models\Question;
use models\User;

class faqController extends Controller
{
    public function indexAction()
    {
        return $this->render(params: [
            'questions' => faqController::editAnswers(Question::getQuestionsList()),
            'isModer' => false,
            'header_page' => 'faq'
        ]);
    }

    public function adminAction()
    {
        $isModer = User::isCurrentUserModerator();
        $questions = faqController::editAnswers(Question::getQuestionsList());
        return $this->render(path: 'views/faq/index.php', params: [
            'questions' => $questions,
            'isModer' => $isModer,
            'header_page' => 'faq'
        ]);
    }

    public function deleteAction($params)
    {
        if (User::isCurrentUserModerator()) {
            $id = $params[0];
            Question::deleteQuestion($id);
        }
        die;
    }

    public function editAction($params)
    {
        if (User::isCurrentUserModerator() && Core::getInstance()->requestMethod == 'POST') {
            $id = $params[0];
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            Question::editQuestion($id, [
                'question' => $question,
                'answer' => $answer
            ]);
        }
        die;
    }

    public function addAction($params)
    {
        if (User::isCurrentUserModerator() && Core::getInstance()->requestMethod == 'POST') {
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            $list_order = count(Question::getQuestionsList()) + 1;
            Question::addQuestion($question, $answer, $list_order);
        }
        die;
    }

    public function changeListOrderAction($params)
    {
        if (User::isCurrentUserModerator() && Core::getInstance()->requestMethod == 'POST') {
            $id = $params[0];
            $list_order = $_POST['list_order'];
            Question::changeListOrder($id, $list_order);
        }
        die;
    }

    private static function editAnswers($questions)
    {
        foreach ($questions as $index => $question)
            $questions[$index]['answer'] = Utils::formatString($question['answer']);
        return $questions;
    }
}