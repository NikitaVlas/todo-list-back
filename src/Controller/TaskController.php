use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
        #[Route('', methods: ['GET'])]
        public function index(EntityManagerInterface $em): JsonResponse
        {
            $tasks = $em->getRepository(Task::class)->findAll();
            return $this->json($tasks);
        }

        #[Route('', methods: ['POST'])]
        public function create(Request $request, EntityManagerInterface $em): JsonResponse
        {
            $data = json_decode($request->getContent(), true);
            $task = new Task();
            $task->setTitle($data['title']);
            $em->persist($task);
            $em->flush();
            return $this->json(['status' => 'Task created!']);
        }

        #[Route('/{id}', methods: ['DELETE'])]
        public function delete(Task $task, EntityManagerInterface $em): JsonResponse
        {
            $em->remove($task);
            $em->flush();
            return $this->json(['status' => 'Task deleted!']);
        }
    }