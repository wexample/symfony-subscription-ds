# Subscription pages: an account's plan and credit, and an administrator's hand on them

The front of symfony-subscription (ticket `subscription-core` there), first
used by Syrtis. Built from the design system's components, none drawn anew: if
one is missing, a ticket to symfony-design-system.

## For the account

A block among the account's pages (those of symfony-user-ds):

- the running plan and since when;
- what is left to consume, or « unlimited »;
- the past subscriptions, with their dates.

## For an administrator

On an account's page:

- the same block;
- putting the account on a plan from now (the package's `subscribe`), a
  confirmation before, the running one ended.

## Later

- The consumption over time as a chart (symfony-charts-ds), once the meter of
  the application says per day.
- The refusals (`no_subscription`, `credit_spent`) are already in the account's
  history (symfony-activity-ds): link to it rather than list them again.
