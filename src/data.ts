export const states = [
  { slug: 'andaman-and-nicobar-islands' },
  { slug: 'andhra-pradesh' },
  { slug: 'arunachal-pradesh' },
  { slug: 'assam' },
  { slug: 'bihar' },
  { slug: 'chandigarh' },
  { slug: 'chhattisgarh' },
  { slug: 'dadra-and-nagar-haveli-and-daman-and-diu' },
  { slug: 'delhi' },
  { slug: 'goa' },
  { slug: 'gujarat' },
  { slug: 'haryana' },
  { slug: 'himachal-pradesh' },
  { slug: 'jammu-and-kashmir' },
  { slug: 'jharkhand' },
  { slug: 'karnataka' },
  { slug: 'kerala' },
  { slug: 'ladakh' },
  { slug: 'lakshadweep' },
  { slug: 'madhya-pradesh' },
  { slug: 'maharashtra' },
  { slug: 'manipur' },
  { slug: 'meghalaya' },
  { slug: 'mizoram' },
  { slug: 'nagaland' },
  { slug: 'odisha' },
  { slug: 'puducherry' },
  { slug: 'punjab' },
  { slug: 'rajasthan' },
  { slug: 'sikkim' },
  { slug: 'tamil-nadu' },
  { slug: 'telangana' },
  { slug: 'tripura' },
  { slug: 'uttar-pradesh' },
  { slug: 'uttarakhand' },
  { slug: 'west-bengal' },
]

export const categories = [
  { slug: 'companies', type: 'company' },
  { slug: 'apps', type: 'app' },
  { slug: 'open-source-projects', type: 'open source project' },
  { slug: 'nonprofits', type: 'nonprofit' },
  { slug: 'institutions', type: 'institution' },
  { slug: 'communities', type: 'community' },
  { slug: 'personal-websites', type: 'personal website' },
  { slug: 'others', type: 'other' },
]

/**
 * Convert a slug into a human readable state name
 * @param slug - Slug of the state
 * @returns Human readable state name
 * @example getStateName('andaman-and-nicobar-islands') // Andaman and Nicobar Islands
 */
export const getStateName = (slug: string) =>
  slug
    .split('-')
    .map((word) => word[0].toUpperCase() + word.slice(1))
    .join(' ')
    .replace(/ And /g, ' & ')
    .replace('Haveli & Daman', 'Haveli and Daman') // Fix for Dadra and Nagar Haveli and Daman and Diu

/**
 * Convert a slug into a human readable category name
 * @param str - String to slugify
 * @returns Slugified string
 */
export const slugify = (str: string) =>
  str
    .toLowerCase()
    .replace(/ /g, '-')
    .replace(/[^\w-]+/g, '')
