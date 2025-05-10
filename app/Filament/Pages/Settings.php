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
    protected static ?int $navigationSort = 100;

    public ?string $language = null;
    public ?string $company_name = null;
    public ?string $company_address = null;
    public ?string $company_phone = null;
    public ?string $company_email = null;
    public $company_logo = null;

    public function mount(): void
    {
        $this->form->fill([
            'language' => App::getLocale(),
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
                Select::make('language')
                    ->label(__('filament.common.fields.language'))
                    ->options([
                        'en' => 'English',
                        'ar' => 'العربية',
                    ])
                    ->default('en')
                    ->required(),
                
                TextInput::make('company_name')
                    ->label('Company Name')
                    ->required(),
                
                TextInput::make('company_address')
                    ->label('Company Address')
                    ->required(),
                
                TextInput::make('company_phone')
                    ->label('Company Phone')
                    ->tel()
                    ->required(),
                
                TextInput::make('company_email')
                    ->label('Company Email')
                    ->email()
                    ->required(),
                
                FileUpload::make('company_logo')
                    ->label('Company Logo')
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
        
        // Set the application locale
        App::setLocale($data['language']);
        
        // Store in session
        session()->put('locale', $data['language']);
        
        // Store in cookie for persistence
        cookie()->queue('locale', $data['language'], 60 * 24 * 30); // 30 days
        
        // Set RTL if Arabic is selected
        if ($data['language'] === 'ar') {
            session()->put('rtl', true);
        } else {
            session()->put('rtl', false);
        }

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

        // Redirect to refresh the page with new locale
        $this->redirect(request()->header('Referer'));
    }

    protected static string $view = 'filament.pages.settings';
} 