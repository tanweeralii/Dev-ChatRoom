# web-whatsapp
A basic web-app to chat and share files. Please visit and explore each page of https://thenewbieprojects.com, where first you have to Register and then enjoy chatting.

## Getting Started
1. ````php```` is backend lanuage.
2. ````Jquery```` is used in frontend.
3. Database to store user credentials and text-messages is ````postgres````.
4. **AWS S3** is used to store files.
5. **AWS LightSail** instance is used for socket server.

## Installation
````
1. $ git clone https://github.com/tanweeralii/web-whatsapp
2. Copy all the files to the directory /var/www/html
3. Run main.sql.
4. change the ip address to localhost in socket server and load1.php files
5. Done
````
## Features
- You can reset password if you lost it, by going to Reset page and then an email will be sent to your registered email id with OTP.
- **AWS S3** is used to store the files to prevent the file access through web scrapping. Even the same user cannot manually click on the link and get the file.
- ````postgres```' is used to store credentials and chats as it is known for fast fetching and accessing data than mysql.
- The socket server is hosted on **AWS LightSail** to reduce load on a single server.
