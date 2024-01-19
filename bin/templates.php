<?php

function makeEntityFile($entityName, $tableName)
{
    $entityName = ucfirst($entityName);

    touch("src/Entity/${entityName}.php");

$content =
"<?php
\n
\n
#[Table(name:${$tableName})]
\n
#[\Core\Attributes\TargetRepository(name:${entityName}.'Repository')]
\n
class ${entityName}
\n
{
\n
//you can now declare fields according to the table, plus getters and setters
}
";

$file = fopen("src/Entity/.${$entityName}.php", "w");
fwrite($file,$content);
fclose($file);


}