
            <table class="table table-bordered table-hover w-100">
                
                <tr>
                    <td width="20%">Name</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td width="20%">Username</td>
                    <td>{{ $user->username }}</td>
                </tr>
                <tr>
                    <td width="20%">Email</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td width="20%">Role</td>
                    <td>{{ $user->roles[0]->name }}</td>
                </tr>

            </table>
