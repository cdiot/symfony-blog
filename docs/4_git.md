# Environnements

[Back to summary](index.md)

## Undo a Git commit

To cancel a file addition, a simple rollback while keeping the modifications is enough.

```bash
git reset --soft HEAD^
```

If we judge that the last 3 versions were not good and we want to cancel everything.

```bash
git resert --hard HEAD~3
```

## Move commits to another branch

If a task is mistakenly committed to the wrong branch and you want to commit it again to another branch.

First calculate the number of commits to move in Git using the command :

```bash
git log
```

Then two possible cases, follow the steps below :

### Move commits to a new branch in Git

New branch with all commits from the main(current) branch :

```bash
git branch new branch 
```

Move the current branch back two commits in this example and keeping changes in the working tree :

```bash
git reset --keep HEAD~2 
```

Go to the new branch

```bash
git checkout new branch
```

The last two commits have been removed from main (current branch) and added into a new branch.

### Move commits to an existing branch

I let you look on the internet for this problem but be sure that there is also a solution.
