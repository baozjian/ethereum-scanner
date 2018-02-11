echo "***************************"
date
cd /www/jifen
node ethereum-account-scanner.js
fn=`find . -type f -mmin -3 -name "count.txt"`
if [ "$fn" =  "" ];
then echo "empty file"
exit
fi
fi=`tail -n 2 $fn|sed -n '1p'`.txt
echo "File:"$fi
/usr/bin/php resolve.php $fi
