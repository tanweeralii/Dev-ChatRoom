# web-whatsapp
A basic web-app to chat and share files. Please visit and explore each page of https://thenewbieprojects.com, Register and enjoy chatting.

## Getting Started
1. ````php````.
2. ````Jquery```` is used in frontend.
3. Database to store user credentials and text-messages is ````postgres````.
4. **AWS S3** is used to store files.
5. **AWS LightSail** instance is used for socket server.

## Features
- Reset password by getting OTP in your registered email.
- You can also share files, **AWS S3** is used to store files to prevent file access through web scrapping.
- ````postgres```` is used to store credentials and chats as it is known for faster fetching and accessing data than mysql.
- All the user credentials are salted then hashed and text-messages are encrypted.
- The socket server is hosted on **AWS LightSail** to reduce load on a single server.
- Users can also **block** anyone.
