<template>
  <section class="w-full px-5 py-3 text-center transition-colors duration-300 bg-gray-700">
    <nav>
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 md:p-0">
        <a
          class="flex items-center mr-6 lg:pl-0"
          href="/"
        >
          <div class="text-white">Widgets'R'Us</div>
        </a>
        <button
          data-collapse-toggle="navbar-solid-bg"
          type="button"
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-background focus:outline-none dark:text-gray-400 dark:hover:bg-gray-700 "
          aria-controls="navbar-solid-bg"
          aria-expanded="false"
          @click="toggle"
        >
          <span class="sr-only">Open main menu</span>
          <svg
            v-if="!open"
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 17 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M1 1 h15 M1 7 h15 M1 13 h15"
            />
          </svg>
          <svg
            v-if="open"
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 17 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 1 L1 15 M1 1 L15 15"
            />
          </svg>
        </button>

        <div
          id="navbar-solid-bg"
          class="w-full md:block md:w-auto"
          :class="open ? 'visible':'hidden'"
        >
          <div class=" flex flex-row align-center">
            <ul class="flex flex-col font-medium mt-4 rounded-lg md:flex-row md:ml-8 md:space-x-2 md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
              <template
                v-for="(navItem,key) in navItems"
                :key="key"
              >
                <li>
                  <a
                    :class="{'bg-none hover:text-white hover:bg-none':!isScrolling()}"
                    :href="navItem.route ? route(navItem.route) : navItem.link"
                    class="text-gray-300 hover:text-white hover:bg-background block md:inline-block mt-4 md:mt-0 mr-2 p-3 px-5 md:rounded-full text-sm no-underline uppercase transition-colors duration-300"
                    @click="close"
                  >
                    {{ navItem.label }}
                  </a>
                </li>
              </template>
            </ul>
          </div>
        </div>

      </div>
    </nav>
  </section>
</template>

<script setup lang="ts">
import {computed, ref} from "vue";
import {usePage} from "@inertiajs/vue3";

const open = ref(false)
const scrolling = ref(false)

const page = usePage();

interface NavItem {
  label: string,
  route: string,
  link: string
}

const navItems = computed<Array<NavItem>>(() => {
  return page.props.nav;
})

function scrollListen() {
  scrolling.value = window.pageYOffset > 50
  window.onscroll = () => {
    scrolling.value = window.pageYOffset > 50
  }
}

scrollListen();

function toggle() {
  open.value = !open.value

  if (open.value) {
    document.body.classList.add('overflow-hidden')
  } else {
    document.body.classList.remove('overflow-hidden')
  }
}

function close() {
  open.value = false
}

function isScrolling() {
  return scrolling.value || open.value
}
</script>
