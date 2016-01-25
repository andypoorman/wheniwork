## What is this?

This is my attempt at the REST Scheduler API project here: https://github.com/wheniwork/standards/blob/master/project.md

## User stories

**Please note that this not intended to be a CRUD application.** Only the functionality described by the user stories should be exposed via the API.

- [X] As an employee, I want to know when I am working, by being able to see all of the shifts assigned to me. (GET /shifts)
- [X] As an employee, I want to know who I am working with, by being able to see the employees that are working during the same time period as me. (GET /shifts/*shiftid*)
- [X] As an employee, I want to know how much I worked, by being able to get a summary of hours worked for each week. (GET /shifts/summary/*date*)
- [X] As an employee, I want to be able to contact my managers, by seeing manager contact information for my shifts. (GET /shifts/*shiftid*)
- [X] As a manager, I want to schedule my employees, by creating shifts for any employee. (POST/PUT /shifts)
- [X] As a manager, I want to see the schedule, by listing shifts within a specific time period. (GET /shifts/search/date/*starttime*/*endtime*)
- [X] As a manager, I want to be able to change a shift, by updating the time details. (PUT /shifts)
- [X] As a manager, I want to be able to assign a shift, by changing the employee that will work a shift. (PUT /shifts)
- [X] As a manager, I want to contact an employee, by seeing employee details. (GET /employees/*employeeid*)