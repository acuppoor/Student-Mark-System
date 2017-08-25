<div>
    Login:
    <form type="submit" method="post">
        username: <input type="text" name="username">
        password: <input type="password" name="password">
        <button type="submit">Login</button>
    </form>
</div>

<div>
    Register:
    <form type="submit" method="post">
        name: <input type="text" name="name">
        username: <input type="text" name="username">
        password: <input type="password" name="password">
        retype password: <input type="password" name="password">
        <button type="submit">Sign up</button>
    </form>

    <form> {{csrf_field()}}</form>
</div>