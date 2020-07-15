<?php

// echo "\n\n:: Data received via POST ::\n\n";
// print_r($_POST);
// echo "\n\n:: Files received ::\n\n";
// print_r($_FILES);

$project_id = $_POST['id'];
$project_name = $_POST['title'];
$project_author = $_POST['author'];
$project_description = $_POST['text'];
$project_images = $_FILES['images']['tmp_name'];
$project_action = $_POST['action'][0];

if ($project_action == 'create') {
  // $sql = "INSERT INTO projects (id, name, author, date, tags, description) VALUES (?, ?, ?, ?, ?, ?)";
  // $pdo->prepare($sql)->execute([$project_id, $project_name, $project_author, $project_date, $project_tags, $project_description]);
  echo 'project created';
} elseif ($project_action == 'edit') {
  // $sql = "UPDATE projects SET name=?, author=?, date=?, tags=?, description=? WHERE id=?";
  // $pdo->prepare($sql)->execute([$project_name, $project_author, $project_date, $project_tags, $project_description, $project_id]);
  echo 'project edited';
} elseif ($project_action == 'archive') {
  // $sql = "INSERT INTO archive (id, name, author, date, tags, description) VALUES (?, ?, ?, ?, ?, ?)";
  // $pdo->prepare($sql)->execute([$project_id, $project_name, $project_author, $project_date, $project_tags, $project_description]);
  echo 'project archived';
} elseif ($project_action == 'delete') {
  // $sql = "DELETE FROM projects WHERE id = ?";
  // $pdo->prepare($sql)->execute([$project_id]);
  echo 'project deleted';
}

?>
