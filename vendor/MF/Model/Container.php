<?php
namespace MF\Model;
use App\Connection;
use MF\Model\Model;
class Container
{
  public static function getMoldel($model)
  {
    $model = ucfirst($model);
    $class= "\\App\\Models\\$model";
		$conn = Connection::getDb();
    return new $class($conn);
  }
}
?>