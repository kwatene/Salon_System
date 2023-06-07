using Microsoft.AspNetCore.Mvc;

namespace Salon_System.Controllers
{
    public class ProfileController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }
    }
}
