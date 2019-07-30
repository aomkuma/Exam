<?php
// Routes

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//$app->get('/user/{id}', 'UserController:getUser');
$app->post('/login/', 'LoginController:authenticate');
$app->post('/login/check-permission/', 'LoginController:checkPermission');

$app->post('/user-account/list/admin/', 'UserController:getAdminList');
$app->post('/user-account/get/admin/', 'UserController:getAdminData');
$app->post('/user-account/update/admin/', 'UserController:updateAdminData');

$app->post('/user-account/list/tutor/', 'UserController:getTutorList');
$app->post('/user-account/get/tutor/', 'UserController:getTutorData');
$app->post('/user-account/search/tutor/', 'UserController:searchTutorData');
$app->post('/user-account/update/tutor/', 'UserController:updateTutorData');
$app->post('/user-account/approval/tutor/', 'UserController:approvalTutorData');

$app->post('/user-account/list/ta/', 'UserController:getTAList');
$app->post('/user-account/get/ta/', 'UserController:getTAData');
$app->post('/user-account/update/ta/', 'UserController:updateTAData');

$app->post('/tutor/list/approval/', 'UserController:getTutorListApproval');

$app->post('/bank/list/', 'BankController:getList');

$app->post('/subject/list/manage/', 'SubjectController:getListManage');
$app->post('/subject/list/', 'SubjectController:getList');
$app->post('/subject/get/', 'SubjectController:getData');
$app->post('/subject/update/', 'SubjectController:updateData');
$app->post('/subject/delete/', 'SubjectController:deleteData');

$app->post('/level/list/manage/', 'LevelController:getListManage');
$app->post('/level/list/', 'LevelController:getList');
$app->post('/level/get/', 'LevelController:getData');
$app->post('/level/update/', 'LevelController:updateData');
$app->post('/level/delete/', 'LevelController:deleteData');

$app->post('/exam-sources/list/manage/', 'ExamSourceController:getListManage');
$app->post('/exam-sources/list/', 'ExamSourceController:getList');
$app->post('/exam-sources/get/', 'ExamSourceController:getData');
$app->post('/exam-sources/update/', 'ExamSourceController:updateData');
$app->post('/exam-sources/delete/', 'ExamSourceController:deleteData');

$app->post('/chapter/list/manage/', 'ChapterController:getListManage');
$app->post('/chapter/list/', 'ChapterController:getList');
$app->post('/chapter/get/', 'ChapterController:getData');
$app->post('/chapter/update/', 'ChapterController:updateData');
$app->post('/chapter/delete/', 'ChapterController:deleteData');

$app->post('/topic/list/manage/', 'TopicController:getListManage');
$app->post('/topic/list/', 'TopicController:getList');
$app->post('/topic/get/', 'TopicController:getData');
$app->post('/topic/update/', 'TopicController:updateData');
$app->post('/topic/delete/', 'TopicController:deleteData');

$app->post('/exam-set/manage/list/', 'ExamSetController:getListManage');
$app->post('/exam-set/manage/get/', 'ExamSetController:getData');
$app->post('/exam-set/manage/update/', 'ExamSetController:updateData');

$app->post('/questions/manage/list/', 'QuestionController:getListManage');
$app->post('/questions/manage/get/', 'QuestionController:getData');
$app->post('/questions/manage/update/', 'QuestionController:updateData');

// Default action
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
