Feature: Merging UAT branches
  In order to test all features that are ready
  We need to get the list of ready feature branches
  And merge them into one called uat
  Before merging every feature should be rebased to the latest master branch

  Scenario: merge features list into uat
    Given we have branches:
      | branch                    |
      | feature/101-new-feature   |
      | change/102-change-request |
      | bug/103-bug-fix           |
    Then