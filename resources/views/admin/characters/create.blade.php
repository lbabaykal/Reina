@extends('admin.admin')
@section('title', config('app.name') . ' - Добавление персонажа')
@section('content')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <div class="relative overflow-x-auto shadow-md">
                <div class="p-5 text-xl font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    Добавление персонажа
                </div>
                <form action="{{ route('admin.characters.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label for="full_name_org"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Полное имя на оригинальном @error('full_name_org') {{ $message }} @enderror
                            </label>
                            <input id="full_name_org"
                                   type="text"
                                   name="full_name_org"
                                   value="{{ old('full_name_org') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required
                            />
                        </div>
                        <div>
                            <label for="full_name_ru"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Полное имя на русском @error('full_name_ru') {{ $message }} @enderror
                            </label>
                            <input id="full_name_ru"
                                   type="text"
                                   name="full_name_ru"
                                   value="{{ old('full_name_ru') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required
                            />
                        </div>
                        <div>
                            <label for="full_name_en"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Полное имя на английском @error('full_name_en') {{ $message }} @enderror
                            </label>
                            <input id="full_name_en"
                                   type="text"
                                   name="full_name_en"
                                   value="{{ old('full_name_en') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required
                            />
                        </div>
                        <div>
                            <label for="photo"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Выберите фото  @error('photo') {{ $message }} @enderror
                            </label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-hidden dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                   id="photo"
                                   type="file"
                                   name="photo"
                            >
                        </div>
                    </div>
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Описание</label>
                    <textarea id="message"
                              rows="4"
                              name="description"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Напишите описание..."
                    >{{ old('description') }}</textarea>

                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-hidden focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Добавить</button>
                </form>
            </div>
        </div>
    </div>
@endsection


