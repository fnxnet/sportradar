# sportradar

### My Assumptions
- only in progress matches are stored in ScoreBoard and Repository
- there could be only one in progress match of the same two teams
- some requirements could not be met therefore need to adjust them as both require :
- "Finish match currently in progress. This removes a match from the scoreboard." suggests that there is only one match in progress while last point of requirements suggest opposite "Get a summary of matches in progress ..."
- If there is more in progress matches update need to receive unique id of the match that need to be updated or necessary information needed to find and update - I decided to use immutable Match object     

### Other remarks:
- there could be more constrains to how the logic works like can not start new match for the team unless all previous matches for that team are finished


### Improvements I would personally add
- implement logger to store important information for future debugging
- implement Command Query Separation i.e. StartMatchCommand, GameSummaryQuery etc...  
- implement Interfaces 