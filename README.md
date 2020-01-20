# coffeeBreak
In order to make the code more reusable I will create a new class Team, so if in the future other teams decide to use hip chat there won't be a need for changes 
(only flag has_hip_chat will be changed). Also, if the user changes a team, only the team id will be changed. Class Team contains name of the team and one field hasHipChat 
which shows if a team has hip chat. For now, only Development team has a HipChat. Every user has a unique username and password and can belong to only one team. 
Each logged user can see only preferences for his team, not for the whole company. Class StaffMember relates to two new tables with their id’s (id_user_login for User class and team for team id for Team class). 
We get preferences only for team members that have preferences for that day.
For each user we send notification on Hip chat or on Email depending on which team they belong to. We are using different service for sending Hip Chat notifications or email. 
If the team has a Hip Chat, the user will receive a notification if he has a team chat identifier, if not, an error will appear. 
For a user to receive an email if the team does not use Hip Chart, the user must have an email. 
For testing the application, the following tests are written – 
testStatusOfNotificationIsTrueWithHipChat (If the team that the user belongs to, has a hip chat, and the user has a hip chat identifier, check if notification is send (if status is true)), 
testStatusOfNotificationIsTrueWithoutHipChat (If the team that the user belongs to, doesn`t have hip chat, and the user has an email, check if the email  is send (if status is true)), 
testThrowsExceptionWhenCannotNotify (If the team that the user belongs to, has a hip chat, and the user doesn`t have hip chat identifier, check if there is runtime exception),
testThrowsExceptionWhenCannotSentEmail (If the team that the user belongs to, doesn`t have a hip chat, and the user doesn`t have an email check if there is runtime exception), 
testThrowsExceptionWhenErrorData (If team that the user belongs to not exist, check if there is runtime exception)

Manifest
- `App\Http\Controllers\CoffeeBreakController`
- `App\Models\CoffeeBreakPreference`
- `App\Models\StaffMember`
- `App\Models\Team`
- `App\Models\Users`
- `App\Services\CoffeeBreakService`
- `App\Services\Notifications\EmailService`
- `App\Services\Notifications\HipChatNotifierService`
- `Tests\Unit\CoffeeBreakTest`
Migrations – tables: users, staff_member, coffee_break_preference, team

*In order to make the application more scalable and reusable we can add new classes: Food, Drinks and preferences for them. 
That will let managers add new foods and drinks whenever they want without changing the code. 
This is not implemented in my version, but if you want, I can upgrade it (I didn't want to make a lot of changes to the given code)
