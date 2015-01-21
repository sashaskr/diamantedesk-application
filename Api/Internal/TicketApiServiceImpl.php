<?php
/*
 * Copyright (c) 2014 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */
namespace Diamante\DeskBundle\Api\Internal;

use Diamante\ApiBundle\Annotation\ApiDoc;
use Diamante\ApiBundle\Routing\RestServiceInterface;
use Diamante\DeskBundle\Api\Command;
use Diamante\DeskBundle\Api\Command\AddTicketAttachmentCommand;
use Diamante\DeskBundle\Api\Command\CreateTicketCommand;
use Diamante\DeskBundle\Api\Command\RemoveTicketAttachmentCommand;
use Diamante\DeskBundle\Api\Command\RetrieveTicketAttachmentCommand;

class TicketApiServiceImpl extends TicketServiceImpl implements RestServiceInterface
{
    use ApiServiceImplTrait;

    /**
     * Load Ticket by given ticket id
     *
     * @ApiDoc(
     *  description="Returns a ticket",
     *  uri="/tickets/{id}.{_format}",
     *  method="GET",
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Ticket Id"
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized to see ticket",
     *      404="Returned when the ticket is not found"
     *  }
     * )
     *
     * @param int $id
     * @return \Diamante\DeskBundle\Model\Ticket\Ticket
     */
    public function loadTicket($id)
    {
        return parent::loadTicket($id);
    }

    /**
     * Load Ticket by given Ticket Key
     *
     * @ApiDoc(
     *  description="Returns a ticket by ticket key",
     *  uri="/tickets/{key}.{_format}",
     *  method="GET",
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="key",
     *          "dataType"="string",
     *          "description"="Ticket Key"
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized to see ticket",
     *      404="Returned when the ticket is not found"
     *  }
     * )
     *
     * @param string $key
     * @return \Diamante\DeskBundle\Model\Ticket\Ticket
     */
    public function loadTicketByKey($key)
    {
        return parent::loadTicketByKey($key);
    }

    /**
     * List Ticket attachments
     *
     * @ApiDoc(
     *  description="Returns ticket attachments",
     *  uri="/tickets/{id}/attachments.{_format}",
     *  method="GET",
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Ticket Id"
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized to list ticket attachments"
     *  }
     * )
     *
     * @param int $id
     * @return array|\Diamante\DeskBundle\Model\Attachment\Attachment[]
     */
    public function listTicketAttachments($id)
    {
        return parent::listTicketAttachments($id);
    }

    /**
     * Retrieves Ticket Attachment
     *
     * @ApiDoc(
     *  description="Returns a ticket attachment",
     *  uri="/tickets/{ticketId}/attachments/{attachmentId}.{_format}",
     *  method="GET",
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="ticketId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Ticket Id"
     *      },
     *      {
     *          "name"="attachmentId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Ticket attachment Id"
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized to see ticket attachment",
     *      404="Returned when the attachment is not found"
     *  }
     * )
     *
     * @param RetrieveTicketAttachmentCommand $command
     * @return \Diamante\DeskBundle\Model\Attachment\Attachment
     * @throws \RuntimeException if Ticket does not exists or Ticket has no particular attachment
     */
    public function getTicketAttachment(RetrieveTicketAttachmentCommand $command)
    {
        return parent::getTicketAttachment($command);
    }

    /**
     * Create Ticket
     *
     * @ApiDoc(
     *  description="Create ticket",
     *  uri="/tickets.{_format}",
     *  method="POST",
     *  resource=true,
     *  statusCodes={
     *      201="Returned when successful",
     *      403="Returned when the user is not authorized to create ticket"
     *  }
     * )
     *
     * @param CreateTicketCommand $command
     * @return \Diamante\DeskBundle\Model\Ticket\Ticket
     */
    public function createTicket(CreateTicketCommand $command)
    {
        $this->prepareAttachmentInput($command);
        return parent::createTicket($command);
    }

    /**
     * Adds Attachments for Ticket
     *
     * @ApiDoc(
     *  description="Add attachment to ticket",
     *  uri="/tickets/{ticketId}/attachments.{_format}",
     *  method="POST",
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="ticketId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Ticket Id"
     *      }
     *  },
     *  statusCodes={
     *      201="Returned when successful",
     *      403="Returned when the user is not authorized to add attachment to ticket"
     *  }
     * )
     *
     * @param AddTicketAttachmentCommand $command
     * @return void
     */
    public function addAttachmentsForTicket(AddTicketAttachmentCommand $command)
    {
        $this->prepareAttachmentInput($command);
        parent::addAttachmentsForTicket($command);
    }

    /**
     * Remove Attachment from Ticket
     * @param RemoveTicketAttachmentCommand $command
     * @return string $ticketKey
     * @throws \RuntimeException if Ticket does not exists or Ticket has no particular attachment
     */
    public function removeAttachmentFromTicket(RemoveTicketAttachmentCommand $command)
    {
        return parent::removeAttachmentFromTicket($command);
    }

    /**
     * Delete Ticket by id
     *
     * @ApiDoc(
     *  description="Delete ticket",
     *  uri="/tickets/{id}.{_format}",
     *  method="DELETE",
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Ticket Id"
     *      }
     *  },
     *  statusCodes={
     *      204="Returned when successful",
     *      403="Returned when the user is not authorized to delete ticket",
     *      404="Returned when the ticket is not found"
     *  }
     * )
     *
     * @param $id
     * @return null
     * @throws \RuntimeException if unable to load required ticket
     */
    public function deleteTicket($id)
    {
        parent::deleteTicket($id);
    }

    /**
     * Delete Ticket by key
     *
     * @ApiDoc(
     *  description="Delete ticket by key",
     *  uri="/tickets/{key}.{_format}",
     *  method="DELETE",
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="key",
     *          "dataType"="string",
     *          "description"="Ticket Key"
     *      }
     *  },
     *  statusCodes={
     *      204="Returned when successful",
     *      403="Returned when the user is not authorized to delete ticket",
     *      404="Returned when the ticket is not found"
     *  }
     * )
     *
     * @param string $key
     * @return void
     */
    public function deleteTicketByKey($key)
    {
        parent::deleteTicketByKey($key);
    }

    /**
     * Update certain properties of the Ticket
     *
     * @ApiDoc(
     *  description="Update ticket",
     *  uri="/tickets/{id}.{_format}",
     *  method={
     *      "PUT",
     *      "PATCH"
     *  },
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Branch Id"
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized to update ticket",
     *      404="Returned when the branch is not found"
     *  }
     * )
     *
     * @param Command\UpdatePropertiesCommand $command
     * @return \Diamante\DeskBundle\Model\Ticket\Ticket
     */
    public function updateProperties(Command\UpdatePropertiesCommand $command)
    {
        return parent::updateProperties($command);
    }

    /**
     * Retrieves list of all Tickets. Performs filtering of tickets if provided with criteria as GET parameters.
     * Time filtering parameters as well as paging/sorting configuration parameters can be found in \Diamante\DeskBundle\Api\Command\CommonFilterCommand class.
     * Time filtering values should be converted to UTC
     *
     * @ApiDoc(
     *  description="Returns all tickets.",
     *  uri="/tickets.{_format}",
     *  method="GET",
     *  resource=true,
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not authorized to list tickets"
     *  }
     * )
     *
     * @param Command\Filter\FilterTicketsCommand $ticketFilterCommand
     * @return \Diamante\DeskBundle\Model\Ticket\Ticket[]
     */
    public function listAllTickets(Command\Filter\FilterTicketsCommand $ticketFilterCommand)
    {
        return parent::listAllTickets($ticketFilterCommand);
    }
}
