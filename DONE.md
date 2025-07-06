## Laravel To-Do List – Podsumowanie projektu

### ⚙️ 1. Inicjalizacja projektu i konfiguracja środowiska

Projekt rozpocząłem od utworzenia aplikacji Laravel oraz skonfigurowania środowiska programistycznego w oparciu o Dockera, korzystając z Laravel Sail. Następnie zainstalowałem Laravel Breeze jako system uwierzytelniania z gotowymi widokami logowania i rejestracji oraz Laravel Sanctum do ochrony tras API i zarządzania sesjami. Dodałem również pliki TODO.md i DONE.md do dokumentacji postępów prac.

---

### 📄 2. Projektowanie struktury danych i logiki zadań

Stworzyłem migrację dla tabeli `tasks` z angielskimi nazwami kolumn, a także model `Task` i kontroler `TaskController`, obsługujący dodawanie, edytowanie, usuwanie i wyświetlanie zadań. Zdefiniowałem wszystkie potrzebne trasy z zabezpieczeniem przez `auth` middleware, dbając o to, aby zadania były widoczne tylko dla zalogowanych użytkowników. Każde zadanie jest przypisane do swojego właściciela.

---

### 👥 3. Obsługa wielu użytkowników i testowanie bezpieczeństwa

Przygotowałem testowe dane użytkowników i zadań poprzez seedery oraz przetestowałem działanie systemu autoryzacji i rejestracji. Zadbano o poprawne przypisywanie zadań do użytkowników i zapewniono, że każdy użytkownik widzi wyłącznie swoje zadania.

---

### 🗅️ 4. Dashboard i zarządzanie zadaniami

Zrefaktoryzowałem układ dashboardu i przygotowałem go pod komponenty do zarządzania zadaniami. Stworzyłem widok listy zadań, który umożliwia przeglądanie zadań w formie przejrzystej tabeli. Wdrożony został mechanizm filtrowania zadań po statusie, priorytecie oraz terminie wykonania, co znacznie poprawia użyteczność przy większej liczbie zadań.

---

### 📩 5. Powiadomienia i automatyzacja

Dodałem automatyczne powiadomienia e-mail, które przypominają użytkownikowi o zadaniu na 1 dzień przed terminem wykonania. Wykorzystałem do tego system kolejek Laravel (queues) oraz harmonogram zadań (scheduler), który codziennie uruchamia zadanie wysyłki maila z przypomnieniem.

---

### 🎨 6. Stylizacja i routing

Na zakończenie dostosowałem wygląd widoków logowania, rejestracji oraz resetowania hasła do reszty aplikacji. Poprawiłem również routing głównej strony, tak aby użytkownik po zalogowaniu był automatycznie kierowany do dashboardu z listą swoich zadań.
