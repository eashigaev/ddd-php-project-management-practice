## Domain-Driven Design: Project Management System

### List of requirements

- Project management
    - Specification - describe project
    - Team - add/remove member, change role
    - Activity - start/stop project
- Task management
    - Specification - describe project
    - Activity - assign, evaluate, start/stop, result task
- Policy
    - Closed project is not available for changes. 
    - Closed task or task of closed project are not available for changes.

Single context. Simple ABAC