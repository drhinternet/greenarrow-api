# Remote Lists Upgrade

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Setup](#setup)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Setup

When an existing installation of GreenArrow Studio is upgraded to a version
that has Remote Lists, a variety of new indexes are created in the background.
On large production systems these indexes may take several hours to create.

The process of creating these indexes will happen when the worker process is
restarted as part of the upgrade process (the `post-upgrade` script), so no
manual step is needed to make this happen.

To check on the status of the index creation, the following command is
available. Here's an example of some indexes that have not yet finished.

```
[root@remote-lists ~]# cd /var/hvmail/studio && bundle exec rake db:review_background_indexes
The following indexes are not yet ready: s_stat_clicks__rl_email, s_stat_clicks__rl_distinct_id
```

Here is what will be shown when the indexes are finished.

```
[root@remote-lists ~]# cd /var/hvmail/studio && bundle exec rake db:review_background_indexes
All indexes are ready.
```

If there is a problem with the creation of indexes, Studio will generate log
files specific to this process in the exceptions folder. Those files can be
found in the following location.

```
[root@remote-lists ~]# cd /var/hvmail/studio/log/exceptions && ls postgresql_index_failure*
postgresql_index_failure__2015.04.29-14.02.29.log  postgresql_index_failure__2015.04.29-14.02.31.log
```

The Remote List feature will not be available until the index creation process
has finished. This only applies to the *initial* upgrade to a version that
contains the Remote List feature. This will not apply to subsequent version upgrades.

For new installations, the indexes are created immediately and this does not apply.
