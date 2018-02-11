# ethereum-scanner
## 使用linux shell脚本扫描以太坊（共有链）
#### 由于以太坊缺乏针对address的查询功能，官方也认为没有提供的必要，为了模仿https://etherscan.io/ 写了此脚本。可以实现定时将区块中交易信息录入redis中，提供php查询，返回json文件，输出区块哈希，区块高度，交易哈希，交易value，from，to。 
### 运行环境：CENTOS7
### 预备环境
- 安装nodejs

        [root@lensh] cd ~   （进入到root的家目录，即 /root）

        [root@lensh] wget https://npm.taobao.org/mirrors/node/v6.10.3/node-v8.2.1-linux-x64.tar.xz （安装源码包）

        [root@lensh] xz -d **.tar.xz  

        [root@lensh] tar -xv -f **.tar

        [root@lensh] vi /etc/profile  （编辑配置文件）

        在文件末添加如下代码：

        export NODE_HOME=/root/node-v8.2.1-linux-x64

        export PATH=$PATH:$NODE_HOME/bin

        export NODE_PATH=$NODE_HOME/lib/node_modules

        [root@lensh] source /etc/profile  （让配置文件生效）

        [root@lensh] node -v (查看node.js的版本,如果出现版本号则证明安装成功)

- 安装web3

        sudo npm install -g web3

- 安装php和php-redis

### 配置和运行

- 修改ethereum-account-scanner中的29行，30行，修改host和post为公有链或者私有链rpc地址。

- 修改resolve.php中redis服务地址。

- 修改detail.php中redis服务地址。

- 使用vi /etc/crontab，添加/bin/sh /www/jifen/run.sh >> /www/jifen/run.log 2>&1 设置定时5min，run.log为日志文件。

- 即可使用localhost/detial.php?address=查询地址。



