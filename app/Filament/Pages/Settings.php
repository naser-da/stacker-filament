<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\App;
use Filament\Notifications\Notification;

class Settings extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Settings';
    protected static ?string $title = 'Settings';
    protected static ?string $slug = 'settings';
    protected static ?int $navigationSort = 100;

    public ?array $data = [];
    public ?string $language = null;
    public ?string $company_name = null;
    public ?string $company_address = null;
    public ?string $company_phone = null;
    public ?string $company_email = null;
    public $company_logo = null;
    
    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.settings');
    }
    
    public function getTitle(): string
    {
        return __('filament.navigation.settings');
    }

    public static function getModelLabel(): string
    {
        return __('filament.navigation.settings');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.navigation.settings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.settings');
    }

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => Setting::get('company_name'),
            'company_address' => Setting::get('company_address'),
            'company_phone' => Setting::get('company_phone'),
            'company_email' => Setting::get('company_email'),
            'company_logo' => Setting::get('company_logo'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                
                TextInput::make('company_name')
                    ->label(__('filament.resources.settings.company_name'))
                    ->required(),
                
                TextInput::make('company_address')
                    ->label(__('filament.resources.settings.company_address'))
                    ->required(),
                
                TextInput::make('company_phone')
                    ->label(__('filament.resources.settings.company_phone'))
                    ->tel()
                    ->required(),
                
                TextInput::make('company_email')
                    ->label(__('filament.resources.settings.company_email'))
                    ->email()
                    ->required(),
                
                FileUpload::make('company_logo')
                    ->label(__('filament.resources.settings.company_logo'))
                    ->image()
                    ->directory('company')
                    ->visibility('public')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->maxFiles(1)
                    ->preserveFilenames(),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Save company settings
        Setting::set('company_name', $data['company_name']);
        Setting::set('company_address', $data['company_address']);
        Setting::set('company_phone', $data['company_phone']);
        Setting::set('company_email', $data['company_email']);
        if (isset($data['company_logo'])) {
            Setting::set('company_logo', $data['company_logo']);
        }
        
        Notification::make()
            ->title('Settings updated successfully')
            ->success()
            ->send();

        $this->redirect(request()->header('Referer'));
    }

    public function getViewData(): array
    {
        return [
            'form' => $this->form,
        ];
    }

    public function getView(): string
    {
        return 'filament.pages.settings';
    }
} 