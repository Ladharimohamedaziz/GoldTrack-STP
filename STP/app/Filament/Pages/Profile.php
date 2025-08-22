<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use  Illuminate\Support\Facades\Storage;
class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $title = 'My Profile';
    protected static ?string $navigationLabel = 'Profile';
    protected static string $view = 'filament.pages.profile';

    public ?array $data = [];

    public function mount(): void
    {

        // Optionally load the profile_image relationship if it exists
        $user = Auth::user();
        // If you have a 'profile_image' relationship, uncomment the next line
        // $user->load('profile_image');

        $this->data = [
            'name' => $user->name,
            'email' => $user->email,
            'profile_image' => $user->profile_image ?? null,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
                FileUpload::make('profile_image')
                    ->image()
                    ->avatar()
                    ->directory('avatars'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $user = Auth::user();
        if ($user instanceof \App\Models\User) {
            foreach ($this->form->getState() as $key => $value) {
                $user->{$key} = $value;
            }
            $user->save();
        }

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }
}
