# OAuth applications

OAuth is an open standard for authorization, commonly used as a way for Internet users to authorize websites or applications to access their information on other websites but without giving them the passwords.

#### Why do i need to create a new oAuth application?
Gitftp is open-source, that means you can securely create your own OAuth application and log yourself in with it.

#### Is it secure?
100%, the OAuth application is made under your account and only you and your gitftp installation can access it.
Gitftp does not send its data anywhere else.

#### How many applications do i need to create?
One for Github and one for Bitbucket. Where ever your repository is hosted.
 
#### Removing the application, will it affect gitftp?
Yes, if your login with the application on gitftp and later remove it.
Gitftp will no longer be able to connect to your repository.
in this case add a new OAuth application and log yourself in using the new application.

#### What if my login token expires?
No worries, gitftp will refresh the token if it expires.

#### How do i create Github OAuth application?
1. Goto settings  
2. OAuth applications     
3. Register a new application  
  
**Application name:** _Anything you like_  
**Homepage URL:** http://example.com/dir  
**Authorization URL:** http://example.com/dir/oauth/authorize/github  
Please note: http://example.com/dir/ is the root directory.

#### How do i create Bitbucket OAuth application?
1. Goto Bitbucket settings  
2. Under Access Management click OAuth   
3. Add consumer  
  
**Name:** _Anything you like_  
**Callback URL:** http://example.com/dir/oauth/authorize/bitbucket  
**URL:** http://example.com/dir  
**Permissions:** Account: Read, Projects: Read, Webhooks: Read and Write, Repositories: Read  
Please note: http://example.com/dir/ is the root directory.

