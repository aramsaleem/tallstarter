<div>
    <h2 style="text-align: center;">All Prompt Records (Saved as Users)</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Prompt</th>
                <th>Email</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
