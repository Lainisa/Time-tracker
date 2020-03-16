<form method="post" class="form" action="post.php">
    <fieldset>
        <legend> Creat a new time tracker for a project </legend>
            <div>
                <label for="project">Project name</label>
                    <input required id="project" type="text" name="project" maxlength="100" minlength="3">
                    </input>
            </div>
            <div>
                <label for="about">About</label>
                        <input required class="area" id="about" type="text" name="about" maxlength="500" minlength="3">
                        </input>
            </div>
            <div>
                <input type="submit" value="Submit" class="button"></input>
            </div>
    </fieldset>
</form>
