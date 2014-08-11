<?@unlink(__DIR__.'/log.txt');

function toLog($what)
{
    file_put_contents(__DIR__.'/log.txt', $what.PHP_EOL, FILE_APPEND);
}

register_shutdown_function(function()
{
    toLog('halted');
});
ob_start();
echo 'dummy';

ob_start();
echo 'dummy2';

ob_start();

for($i=2; $i<=20; $i++)
{
    $buffers = array();
    echo ($i*$i).'<br>';
    while(ob_get_level())
        array_unshift($buffers, ob_get_clean());
    echo ' ';
    flush();
    if(connection_aborted())
        exit;
    else
        foreach($buffers as $content)
        {
            ob_start();
            echo $content;
        }
    sleep(1);
}

while(ob_get_level()>1)
    ob_end_flush();
$data = ob_get_clean();
echo "Результат мега-вычеслений:<br>".$data;