@extends('admin.admin')
@section('title', config('app.name') . ' - Персоны')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <div class="relative overflow-x-auto shadow-md">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <caption class="p-5 text-xl font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                        Список персон
                        @if ($message = session('message'))
                            - <span class="text-lime-500">{{ $message }}</span>
                        @endif
                        <p class="mt-1 text-base text-red-500 dark:text-gray-400">
                            <a href="{{ route('admin.persons.create') }}">
                                Добавить персону
                            </a>
                        </p>
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Фото
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Полное имя
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Edit
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($persons as $person)
                        <tr class="odd:bg-white dark:odd:bg-gray-900 even:bg-gray-50 dark:even:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <img src="{{ $person->photoUrl }}" width="100px" alt="">
                            </th>
                            <td class="px-6 py-4">
                                {{ $person->full_name_org }}<br>
                                {{ $person->full_name_ru }}<br>
                                {{ $person->full_name_en }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.persons.edit', $person->slug) }}"
                                   class="hover:text-love"
                                >
                                    Редактировать
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $persons->links() }}
        </div>
    </div>
@endsection


