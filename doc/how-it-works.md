# how it all works
Most of your might know the flow of how this works, however i will write down the specifics

### OAuth application
Lets consider GitHub to be your Git provider.  
In order to connect to Github, you create a OAuth application and share its credentials with Gitftp.
therefore gitftp has access to your OAuth application. (BUT does not have access to your repositories yet.)  
More about OAuth application [here](oauth-application.md)

### Connecting to Github using OAuth application
You login to github with your created OAuth application. and finally Gitftp gets access to your repositories  
The access chain looks like this: 
```
Gitftp -> Your OAuth application -> Your account.
```
**NOTE: Gitftp only takes read access to your repositories.**

### Creating a project
When you create a project  
Gitftp creates webhooks on your repositories  
It helps let know gitftp about the pushes you make to your repository
