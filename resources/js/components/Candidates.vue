<template>
  <div>
    <div class="p-10">
      <h1 class="text-4xl font-bold">Candidates</h1>
    </div>
    <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
      <div v-for="candidate in allCandidates" class="rounded overflow-hidden shadow-lg" v-show="Object.values(JSON.parse(candidate.strengths)).indexOf('Wordpress') < 0">
        <img class="w-full" src="/avatar.png" alt="">
        <div class="px-6 py-4">
          <div class="font-bold text-xl mb-2">{{ candidate.name }}</div>
          <p class="text-gray-700 text-base">{{ candidate.description }}</p>
        </div>
        <div class="px-6 pt-4 pb-2"><span v-for="strength in JSON.parse(candidate.strengths)"
            class="inline-block rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2" :class="[desiredStrengths.includes(strength) ? 'bg-green-200' : 'bg-gray-200']">{{
              strength }}</span>
        </div>
        <div class="px-6 pb-2"><span v-for="skill in JSON.parse(candidate.soft_skills)"
            class="inline-block rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2" :class="[desiredSoftSkills.includes(skill) ? 'bg-green-200' : 'bg-gray-200']">{{ skill
            }}</span>
        </div>
        <div class="p-6 float-right">
          <VueLoadingButton aria-label="Post message"
            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
            @click.native="contactCandidate(candidate.id)" :loading="isLoading"
            :disabled="(coins < 1) || candidate.contact">
            <span v-if=candidate.contact>Contacted</span>
            <span v-else>Contact</span>
          </VueLoadingButton>
          <VueLoadingButton aria-label="Post message"
            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
            @click.native="hireCandidate(candidate.id)"
            :loading="isLoading"
            :disabled="!candidate.contact || candidate.hired"
          >
            <span v-if=candidate.hired>Hired</span>
            <span v-else>Hire</span>
          </VueLoadingButton>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueLoadingButton from 'vue-loading-button';

export default {
  props: ['coins'],
  data() {
    return {
      desiredStrengths: [
        'Vue.js', 'Laravel', 'PHP', 'TailwindCSS'
      ],
      desiredSoftSkills: [
        'Team player', 'Leadership', 'Conflict management', 'Diplomacy'
      ],
      isLoading: false,
      allCandidates: {},
    }
  },
  mounted() {
    this.getCandidates();
  },
  methods: {

    getCandidates: async function () {
      await axios.get('api/candidates').then(({ data }) => {

        if (data.status_code == 200) {
          this.allCandidates = data.candidates;
        }
      }).catch(error => {
        console.error(error);
      })
    },

    contactCandidate: async function (candidateId) {
      this.isLoading = true;
      await axios.post('api/candidates-contact/' + candidateId).then(({ data }) => {
        this.isLoading = false;
        if(data.status_code == 200){
          this.getCandidates();
        }
      }).catch(error => {
        console.error(error);
      })
    },
    
    hireCandidate: async function (candidateId) {
      this.isLoading = true;
      await axios.post('api/candidates-hire/' + candidateId).then(({ data }) => {
        this.isLoading = false;
        if(data.status_code == 200){
          this.getCandidates();
        }
      }).catch(error => {
        console.error(error);
      })
    },
  },
}
</script>
