# Билдер для моделей. (MVP, namespace bulder будет переведен в отдельный пакет)

namespace bulder содержит набросок библиотеки для создания моделей при помощи билдера. 

Пример использования в рамках symfony:
```PHP
#[Route('/', name: 'index')]
public function index(Builder $taskBuilder): Task
{
    $taskBuilder
        ->setTitle('this is task')
        ->setDescription('Lorem ...')
    ;

    return $taskBuilder->build();
}

// пример модели
class Task
{
    private string $title;

    public string $description;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
```

Для билдинга моделей имеется несколько "путей":
```PHP
interface Ways
{
    public const CONSTRUCTOR = 1;
    public const PUBLIC_FIELDS = 2;
    public const SETTERS = 4;
    public const REFLECTION = 8;
    public const ANY = 15;
}
```

Путь через конструктор создает модель с помощью конструктора, остальные по аналогии.
Исключение путь "ANY", этот путь использует анализ модели и подбирает необходимый путь
для каждого поля.


Пути можно устанавливать для билда в самом методе билдинга (по умолчанию используется `Ways::ANY``):
```PHP
#[Route('/', name: 'index')]
public function index(Builder $taskBuilder): Task
{
    $taskBuilder
        ->setTitle('this is task')
        ->setDescription('Lorem ...')
    ;

    return $taskBuilder->build(Ways::CONSTRUCTOR);
}
```


Пути также можно устанавливать индивидуально для каждого поля:
```PHP
#[Route('/', name: 'index')]
public function index(Builder $taskBuilder): Task
{
    $taskBuilder
        ->setTitle('this is task', Ways::SETTERS)
        ->setDescription('Lorem ...', Ways::PUBLIC_FIELDS)
    ;

    return $taskBuilder->build();
}
```

Пути можно комбинировать:
```PHP
#[Route('/', name: 'index')]
public function index(Builder $taskBuilder): Task
{
    $taskBuilder
        ->setTitle('this is task', Ways::PUBLIC_FIELDS | Ways::SETTERS)
        ->setDescription('Lorem ...')
    ;

    return $taskBuilder->build(Ways::CONSTRUCTOR | Ways::REFLECTION);
}
```
