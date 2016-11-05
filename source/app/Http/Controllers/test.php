<?php

fscanf(STDIN, "%d\n", $computer);
fscanf(STDIN, "%d\n", $cable);

for($i=0;$i<$cable;$i++)
{
    fscanf(STDIN, "%d %d %d\n",  $list[$i][$j++],$list[$i][$j++],$list[$i][$j++]);
}
for($i=0;$i<$cable;$i++)
{
    echo $list[$i][$j];
}