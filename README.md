# CentOS 7 安裝 Docker

### Step 1. 安裝套件
```
yum install -y yum-utils device-mapper-persistent-data lvm2
```
### Step 2. 新增 yum repository
```
yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
```
### Step 3. 利用 yum 安裝最新版本 Docker，若要指定版本則在指令後面加上 -<version>
```
yum install docker-ce
```
### Step 4. 安裝完成後啟動 Docker
```
systemctl start docker
```
### Step 5. 確認 Docker 版本
```
docker version
```
### Step 6. 查看 Docker 詳細狀態
```
docker info
```
### Step 7. 測試 Docker 是否正確啟動， 此指令會下載一個測試的 Image 並且運行於一個 Container 中
```
docker run hello-world
```
將會看到訊息:
```
Hello from Docker!
This message shows that your installation appears to be working correctly.
```
===================================================================================

# CentOS 7 安裝 docker-compose

### Step 1. 安裝套件
```
yum install curl
```
### Step 2. 下載並安裝 docker-compose
```
curl -L "https://github.com/docker/compose/releases/download/1.27.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```
### Step 3. 開啟執行權限給 docker-compose
```
chmod +x /usr/local/bin/docker-compose
```
### Step 4. 確認 docker-compose 版本
```
docker-compose --version
```
將會看到訊息:
```
docker-compose version 1.27.4, build 40524192
```
===================================================================================

# 啟動專案

將專案 Download 下來，我們在Symfony底下，docker目錄結構應該會像下列這樣
```
docker-image/
│
├── docker-compose.yml
│
├── data/
│   └── my.cnf   
│
├── php-fpm/
│   ├── composer.sh
│   ├── Dockerfile
│   ├── php.ini
│   ├── supervisord.conf
│   └── www.conf
│
└─── nginx/
    └── default.conf
```

之後在 docker-image/ 底下執行指令

### Step 1. 將所有容器依照 docker-compose.yml 建立起來
```
docker-compose up -d --build
```
將會看到訊息:
```
Creating network "docker-image_symfony" with the default driver
Creating mysql ... done
Creating php-fpm ... done
Creating nginx   ... done
```

### Step 2. 確認所有容器的狀態跟埠口是否正確
```
docker-compose ps
```
將會看到訊息:
```
 Name                Command               State                 Ports              
------------------------------------------------------------------------------------
mysql     docker-entrypoint.sh mysqld      Up      0.0.0.0:3306->3306/tcp, 33060/tcp
nginx     /docker-entrypoint.sh ngin ...   Up      0.0.0.0:80->80/tcp               
php-fpm   /usr/bin/supervisord -c /e ...   Up      0.0.0.0:9000->9000/tcp
```

### Step 3. 打開 Client 瀏覽器確認是否正確顯示 Symfony 歡迎畫面
```
http://<ServerIP>
```
將會看到訊息:
```
Welcome to Symfony <version>

Your application is now ready. You can start working on it at:
/usr/share/nginx/html/
```

### Step 4. 開啟 Client 瀏覽器，開始使用留言板吧！
```
http://<ServerIP>/message
```

> 若無法執行composer安裝腳本請參考 "https://getcomposer.org/download/" 最新發布版安裝


### Copyright © 2020 MinoRaiNy
    

