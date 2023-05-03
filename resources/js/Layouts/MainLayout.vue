<!-- Main Layout -->
<template>
  <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full">
    <div class="container mx-auto">
      <nav class="p-4 flex items-center justify-between">
        <div class="text-lg font-medium">
          <Link :href="route('listing.index')">Listings</Link>
        </div>
        <div class="text-xl text-blue-600 dark:text-blue-300 font-bold text-center">
          <Link :href="route('listing.index')">LaraState</Link>
        </div>

        <div v-if="user" class="flex items-center gap-4">
          <Link
            class="text-gray-500 relative pr-2 py-2 text-lg"
            :href="route('notification.index')"
          >
            🔔
            <div v-if="notificationCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
              {{ notificationCount }}
            </div>
          </Link>

          <Link class="text-sm text-gray-500" :href="route('realtor.listing.index')">{{ user.name }}</Link>
          <Link :href="route('realtor.listing.create')" class="btn-primary">+ New Listing</Link>
          <div>
            <Link :href="route('logout')" method="delete" as="button">Logout</Link>
          </div>
        </div>
        <div v-else class="flex items-center gap-2">
          <Link :href="route('user-account.create')">Register</Link>
          <Link :href="route('login')">Sign-In</Link>
        </div>
        <div class="text-right">
          <button @click="toggleDarkMode">🌙</button>
        </div>
      </nav>
    </div>
  </header>

  <main class="container mx-auto p-4 w-full">
    <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2">
      {{ flashSuccess }}
    </div>
    <slot>Default</slot>
  </main>
</template>

<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
const page = usePage()

console.log('page.props',page.props)

// flash success message
const flashSuccess = computed(
    () => page.props.flash.success,
)

// get the user from the page props
const user = computed(
    () => page.props.user,
)

// get the notification count from the page props
const notificationCount = computed(
    () => Math.min(page.props.user.notificationCount, 9),
)

// toggle dark mode
const toggleDarkMode = () => {
    document.querySelector('html').classList.toggle('dark')
    // set toggle sun/moon icon
    document.querySelector('button').innerHTML = document.querySelector('html').classList.contains('dark') ? '☀️' : '🌙'

    // store the dark mode preference in local storage
    localStorage.setItem('darkMode', document.querySelector('html').classList.contains('dark'))
}

const loadDarkMode = () => {
    // load the dark mode preference from local storage
    const darkMode = localStorage.getItem('darkMode')

    // if dark mode is set to true, set the class on the html element
    if (darkMode === 'true') {
        document.querySelector('html').classList.add('dark')
        document.querySelector('button').innerHTML = '☀️'
    }
}

loadDarkMode() // load the dark mode preference on page load
</script>
