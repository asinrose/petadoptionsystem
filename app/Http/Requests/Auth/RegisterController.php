protected function create(array $data)
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => isset($data['is_service_provider'])
                    ? 'service_provider'
                    : 'user',
    ]);
}
