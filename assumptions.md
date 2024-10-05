## 1. Assumption about Frontend Framework (React vs. Vue):

I implemented the frontend using React.js instead of Vue.js as React was the framework I was more familiar with when compared to vue.
## 2. Assumption about OAuth Implementation:

I used React OAuth2 for the Google login integration
tried using php google oauth - getting error on 

```bash
$redirectUri() - getting resitriced or sometimes showing response url. 
Google\Service\Oauth($client) - getting Undefined type - need for to get the user info
```
currently working on this - will share update. 

## 3. Assumption about REST Services:

Implemented the REST services using php - but for questing route testing - 
if user enter junk params after questions/junk/junk - it crashes the page with 404 error - blank screen

## 4. Assumption about User Interface:

I did not focus heavily on the user interface design and used basic CSS files from Vite to keep the styling minimal. The core functionality of the quiz application (OAuth login, quiz questions, and score display) was prioritized over UI/UX details.

## 5. Assumption about Future Extensibility:

The quiz application is designed to be extended easily, allowing for additional quiz topics, questions, or levels to be added in the future without major changes to the codebase.

## 6. Assumption about User Data:

The project mentioned that there was no need to save user data, but I'm to store the user's email in the database when they log in using Google OAuth. This allows tracking of users' activity within the application.
