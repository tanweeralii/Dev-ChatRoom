# Dev-ChatRoom
A basic web-app to chat and share files. Please visit and explore each page of https://thenewbieprojects.com, Register and enjoy chatting.

## Features
- Reset password by getting OTP in your registered email.
- You can also share files, **AWS S3** is used to store files to prevent file access through web scrapping.
- ````postgres```` is used to store credentials and chats as it is known for faster fetching and accessing data than mysql.
- All the user credentials are salted then hashed and text-messages are encrypted.
- The socket server is hosted on **AWS LightSail** to reduce load on a single server.
- Users can also **block** anyone.
